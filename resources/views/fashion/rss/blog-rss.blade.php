{!! '<'.'?'.'xml version="1.0" encoding="UTF-8" ?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:media="http://search.yahoo.com/mrss/">
    <channel>
        <title>Franceloop {{$site['title']}}</title>
        <link>{{$site['link']}}</link>
        <description><![CDATA[{!! $site['descr'] !!}]]></description>
        <atom:link href="{{$site['link']}}" rel="self" type="application/rss+xml" />
        <language>en</language>
        <lastBuildDate>{{ $articles[0]->created_at->format(DateTime::RSS) }}</lastBuildDate>
        @foreach($articles as $article)
            <item>
                <title><![CDATA[{!! $article->article_header !!}]]></title>
                <link>{{ route('fashion-blog-article-page',['article_url'=>$article->article_seo_url]) }}</link>
                <guid isPermaLink="true">{{ route('fashion-blog-article-page',['article_url'=>$article->article_seo_url]) }}</guid>
                <description><![CDATA[{!! substr($article->article_text,0,200).'...'!!}]]></description>
                <content:encoded><![CDATA[{!! $article->article_text !!}]]></content:encoded>
                <dc:creator xmlns:dc="http://purl.org/dc/elements/1.1/">Author</dc:creator>
                <pubDate>{{ $article->created_at->format(DateTime::RSS) }}</pubDate>
            </item>
        @endforeach
    </channel>

</rss>
