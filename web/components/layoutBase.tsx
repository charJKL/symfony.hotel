import type { NextPage } from 'next';
import Header from "./fragments/header";
import Nav from "./fragments/nav";
import Footer from "./fragments/footer";

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
			<main>{ children }</main>
			<Footer />
		</>
	)
}

export default LayoutBase;