import React, { useState } from 'react'


const Nav2 = ({ pages, logo }) => {
    const [open, setOpen] = useState(false)

    const switchState = () => {
        setOpen(!open)
    }
    
    return (
        <div id="sidebar" class="h-screen w-half menu bg-white text-white px-4 flex items-top nunito static fixed shadow">
        <ul class="list-reset mt-4 text-center">
            <li class="my-1 md:my-0">
            {logo ?
                    <a href={window.location.host}>
                        <img className="h-12" src={logo} alt="logo" />
                    </a>
                    : <div className="h-12"></div>}
            </li>
            <li class="my-2 md:my-0 ">
            {pages.map((page, i) => {
                    return (
                        <a key={i} href={page.url}
                            className="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                            {page.title}
                        </a>
                    )
                })}
            </li>
        </ul>

    </div>


    )
}

export default Nav2