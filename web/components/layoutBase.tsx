import type { NextPage } from 'next';
import { useContext } from 'react';
import AuthenticationContext from '../services/AuthenticationContext';
import Head from 'next/head'
import Header from "./fragments/header";
import Nav from "./fragments/nav";
import Services from "./fragments/services";
import Authentication from "./fragments/authentication";
import Main from "./fragments/main";
import Footer from "./fragments/footer";
import style from "./layoutBase.module.scss";

type LayoutBaseProps =
{
	children: React.ReactNode;
}

const LayoutBase = ({children}: LayoutBaseProps) : JSX.Element => 
{
	const {isAuthenticated} = useContext(AuthenticationContext);
	
	const user = isAuthenticated ? <Services /> : <Authentication /> ;
	return (
		<>
			<Head>
				<title>NoName hotel</title>
				<meta name="description" content="Generated by create next app" />
				<meta name="viewport" content="initial-scale=1, width=device-width" />
				<link rel="icon" href="/favicon.ico" />
			</Head>
			
			<Header />
			<Nav />
			{ user }
			<Main>{ children }</Main>
			<Footer />
		</>
	)
}

export default LayoutBase;