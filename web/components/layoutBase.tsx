import type { NextPage } from 'next';
import Header from "./fragments/header";
import Nav from "./fragments/nav";
import Footer from "./fragments/footer";
import style from "./layoutBase.module.scss";

type LayoutBaseProps =
{
	children: React.ReactNode;
}

const LayoutBase = ({children}: LayoutBaseProps) : JSX.Element => 
{
	return (
		<>
			<Header />
			<Nav />
			<main className={style.main}>{ children }</main>
			<Footer />
		</>
	)
}

export default LayoutBase;