import type { NextPage, GetStaticProps, GetStaticPaths } from 'next'
import apiBuild from "../../services/ApiBuild";
import type Offer from "../../entities/Offer";
import css from "./[slug].module.scss";

type OfferProps = Offer;

const Offer = ({id, name, description} : OfferProps) => {
	
	const stylesForHeader = {color: '#00f'}
	return (
		<div className={css.page}>
			<h1 className={css.header} style={stylesForHeader}>{ name }</h1>
			<p>{ description }</p>
		</div>
	);
}

export const getStaticProps : GetStaticProps = async () => {
	const offer : Offer = {
		id: 0,
		slug: 'rainy-autumn',
		name: "Rainy autumn",
		description: "Lorem ipsum more text",
		image: "/"
	}

	return {
		props: {
			...offer
		}
	};
}

export default Offer;