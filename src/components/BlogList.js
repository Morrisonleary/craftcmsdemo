import React from 'react'

const BlogListItem = ({ news }) => {
    return (
        <article className="flex flex-row p-2">
            <div className="flex flex-col flex-grow">
                <a href={news.url} className="flex flex-grow-0 bold text-lg"><h2>{news.title}</h2></a>
                <p className="flex flex-grow text-md">{news.excerpt}</p>
            </div>
            <a href={news.url} className="flex-none h-20 w-20 ml-4">
                <img className="object-cover h-full" src={news.featureImage}>
                </img>
            </a>
        </article>
    )
}

const BlogList = ({ news }) => {
    return (
        <section className="w-full grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-4">
            {news.map((news, i) => {
                return <BlogListItem key={i} news={log} />
            })}
        </section>
    )
}

export default BlogList