import type { NextPage } from 'next';
import Header from "./fragments/header";
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
			<main>{ children }</main>
			<Footer />
		</>
	)
}

export default LayoutBase;