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

type OfferParams = 
{
	id: string;
}

export const getStaticProps : GetStaticProps<OfferParams> = async () => {
	const offer = await apiBuild.get(`/offers/sunny-winter.json`);
	
	return {
		props: {
			...offer.data
		}
	};
}

export default Offer;