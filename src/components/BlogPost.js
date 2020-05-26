import React from 'react'
import PostContent from './PostContent'

const BlogPost = ({ news }) => {

    return (
        <article className="w-full">
            {news.featureImage ?
                <figure style={{
                    height: '60vh',
                    backgroundImage: `url(${news.featureImage})`,
                    backgroundPosition: 'center',
                    backgroundRepeat: 'no-repeat',
                    backgroundSize: 'cover'
                }} className="w-full overflow-hidden">
                </figure>
                : <></>
            }

            <div className="w-full py-4 sm:px-4 lg:px-16">
                <header className="mb-8 text-center">
                    <h1 className="bold text-4xl">{news.title}</h1>
                    <time className="bold text-lg text-indigo-700" dateTime={news.date_published}>
                        {new Date(news.date_published).toDateString()}
                    </time>
                </header>
                <PostContent content={news.content || []} />
            </div>
        </article>
    )
}

export default BlogPost