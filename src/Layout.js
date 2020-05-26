import React from 'react'
import Nav from './components/Nav'


const Layout = ({ children, site }) => {
	return (
		<div>
			<div>
				<header>
					<Nav pages={site?.pages || []} logo={site?.logo} />
				</header>
				<main>
					{children}
				</main>
				<footer>
					{site?.footerText}
				</footer>
			</div>
		</div>
	)
}

export default Layout