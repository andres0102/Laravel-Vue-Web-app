<?php
/**
 * Created by Vladislav.
 * Date: 2019-06-04
 * Time: 12:56
 */

namespace App\Http\Controllers\Checkout;
use App\Models\Checkout\Bag;
use App\Models\Checkout\BagItems;
use App\Models\Products\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
class BagController extends Controller
{
    /**
     * adding product ot bag wiht options
     * */
    public function addProductToBag(Request $request){
        $currentUser = JWTAuth::user();
        $bag = Bag::where('user_id','=',$currentUser['id'])->first();
        $bagId=0;
        if($bag){
            $bagId = $bag->id;
            $bagItems = BagItems::where(['bag_id'=>$bagId, 'product_id'=>$request->get('product_id'), 'options'=>json_encode($request->get('options'))])->first();
            if($bagItems){
                $bagItems->update([
                    'total' =>(float)$bagItems->price*((int)$bagItems->quantity+1),
                    'quantity'=>(int)$bagItems->quantity+1

                ]);
            }else{
                BagItems::create([
                    'bag_id'=>$bagId,
                    'product_id'=>$request->get('product_id'),
                    'price'=>str_replace('$','',$request->get('price')),
                    'options'=>json_encode($request->get('options')),
                    'quantity'=>1,
                    'total'=>str_replace('$','',$request->get('price')),
                ]);

            }

        }else{
            $bagId = Bag::create([
                'user_id'=>$currentUser['id'],
            ])->id;
            BagItems::create([
                'bag_id'=>$bagId,
                'product_id'=>$request->get('product_id'),
                'price'=>str_replace('$','',$request->get('price')),
                'options'=>json_encode($request->get('options')),
                'quantity'=>1,
                'total'=>str_replace('$','',$request->get('price')),
            ]);
        }

        return response()->json(['success' => 'success','count'=>$bag->getCountBagItems()], 200);

    }

    public function checkBag(Request $request){
        $currentUser = JWTAuth::user();
        $count = 0;
       try{
           $bag = Bag::where('user_id','=',$currentUser['id'])->firstOrFail();
           $count = $bag->getCountBagItems();
       }catch (\Exception $error){

       }
        return response()->json(['success' => 'success','count'=>$count], 200);

    }

    /**
     * viewing the bag page
     *@return view page
     * */
    public function view() {
        $currentUser = JWTAuth::user();
        if(!$currentUser){
            return redirect('/');
        }
        $bag = Bag::where("user_id",$currentUser->id)->first();
        $products = [];
        $total= 0;
        if($bag) {
            $bagItems = BagItems::where('bag_id', $bag->id)->get();

            foreach ($bagItems as $bagItem){
                $productInfo = Products::findOrFail($bagItem->product_id);
                $optionsArray = json_decode($bagItem->options);
                $itemOptionText = '';
                foreach ($optionsArray as $key => $item) {
                    $itemOptionText.=$key.': '.$item->name."\n";
                }
                $products[] = [
                    'id'=>$bagItem->id,
                    'thumb'=>$productInfo->thumb_url,
                    'name'=>$productInfo->name,
                    'options'=>$itemOptionText,
                    'total' => $bagItem->total,
                    'price'=>$bagItem->price,
                    'quantity' => $bagItem->quantity
                ];
                $total+=$bagItem->total;
            }
        }
        return view('checkout.bag')->with(['products' => $products,'total'=>$total]);
    }
    public function updateBagItem(Request $request){
        $currentUser = JWTAuth::user();
        if(!$currentUser){
            return response()->json([
                'status' => 'error',
                'error' => 'failed_logout',
                'msg' => 'Failed to logout, please try again.'
            ], 500);
        }
        /*updating bag item*/
        $bagItem = BagItems::find($request->get('bag_id'));
        if($request->get('quantity') <= 0){
            $bagItem->delete();
        }else {
            $bagItem->update([
                'quantity' => $request->get('quantity'),
                'total' => (float)$bagItem->price * (int)$request->get('quantity'),
            ]);
        }
        /*calculating total*/
        $bag = Bag::where("user_id",$currentUser->id)->first();
        $total= 0;
        $quantity =0;
        if($bag) {
            $bagItems = BagItems::where('bag_id', $bag->id)->get();
            foreach ($bagItems as $bagItem){
                $total+=$bagItem->total;
                $quantity+=$bagItem->quantity;
            }
        }
        return response()->json([
            'status' => 'success',
            'total'=>$total,
            'quantity' => $quantity,
        ], 200);

    }
    /**
     * Sending payment info
     * @return json array
     */
    public function sendPayment(Request $request){
        $data= [];
        $data= $request->all();
        $currentUser = JWTAuth::user();
        if(!$currentUser){
            return response()->json([
                'status' => 'error',
                'error' => 'failed_logout',
                'msg' => 'Failed to logout, please try again.'
            ], 500);
        }
        /*getting bag */
        $bag = Bag::where("user_id",$currentUser->id)->first();
        $amount = $bag->getBagTotal();
        $items = $bag->getBagItems();
        $desc = '';
        foreach ($items as $item ){
            $product = Products::findOrFail($item->product_id);
            $desc.= $product->name.';';
        }

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName('7P346qvmSu');
        $merchantAuthentication->setTransactionKey('65JNQk6ysc883534');
        $message = '';
        if(!$data['cardNumber'] || !$data['cardExYear'] || !$data['cardExMonth'] ||  !$data['cardExMonth'] || $data['cardCode'] ){
            $message = 'Wrong card infromation';
        }
        // Set the transaction's refId
        $refId = 'ref' . time();
        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($data['cardNumber']);
        $creditCard->setExpirationDate($data['cardExYear'].'-'.$data['cardExMonth']);
        $creditCard->setCardCode($data['cardCode']);
        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);
        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($bag->id);
        $order->setDescription("Buying products: ".$desc);
        // Set the customer's Bill To address
        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($currentUser->name);
        $customerAddress->setLastName("Johnson");
        $customerAddress->setCompany("no company");
        $customerAddress->setAddress("14 Main Street");
        $customerAddress->setCity("Pecan Springs");
        $customerAddress->setState("TX");
        $customerAddress->setZip("44628");
        $customerAddress->setCountry("USA");
        // Set the customer's identifying information
        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType("individual");
        $customerData->setId($currentUser->id);
        $customerData->setEmail($currentUser->email);
        // Add values for transaction settings
        $duplicateWindowSetting = new AnetAPI\SettingType();
        $duplicateWindowSetting->setSettingName("duplicateWindow");
        $duplicateWindowSetting->setSettingValue("60");
        // Add some merchant defined fields. These fields won't be stored with the transaction,
        // but will be echoed back in the response.
//        $merchantDefinedField1 = new AnetAPI\UserFieldType();
//        $merchantDefinedField1->setName("customerLoyaltyNum");
//        $merchantDefinedField1->setValue("1128836273");
//        $merchantDefinedField2 = new AnetAPI\UserFieldType();
//        $merchantDefinedField2->setName("favoriteColor");
//        $merchantDefinedField2->setValue("blue");
        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setCustomer($customerData);
        $transactionRequestType->addToTransactionSettings($duplicateWindowSetting);
//        $transactionRequestType->addToUserFields($merchantDefinedField1);
//        $transactionRequestType->addToUserFields($merchantDefinedField2);
        // Assemble the complete transaction request
        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);
        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getMessages() != null) {
//                    echo " Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n";
//                    echo " Transaction Response Code: " . $tresponse->getResponseCode() . "\n";
//                    echo " Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n";
//                    echo " Auth Code: " . $tresponse->getAuthCode() . "\n";
//                    echo " Description: " . $tresponse->getMessages()[0]->getDescription() . "\n";
                } else {
                    //echo "Transaction Failed \n";
                    if ($tresponse->getErrors() != null) {
//                        echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
//                        echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                //echo "Transaction Failed \n";
                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
//                    echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
//                    echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
                } else {
//                    echo " Error Code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
//                    echo " Error Message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
                }
            }
        } else {
            //echo  "No response returned \n";
        }
        return response()->json([
            'data'=>$response,
            'message'=>$message,
        ], 200);
    }
}
