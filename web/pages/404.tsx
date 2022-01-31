import type { NextPage } from 'next'
import css from "./404.module.scss";

const Error404: NextPage = () => {
	return (
		<div className={css.page}>
			<h1>Error 404</h1>
			<h2>Page not found</h2>
		</div>
	);
}

export default Error404