import type { NextPage, GetStaticProps, GetStaticPaths } from 'next'
import apiBuild from "../../services/ApiBuild";
import type Offer from "../../entities/Offer";
import css from "./[slug].module.scss";

type OfferProps = Offer;

const Offer = ({id, name, description} : OfferProps) => {
	return (
		<div className={css.page}>
			<h1 className={css.header}>{ name }</h1>
			<p>{ description }</p>
		</div>
	);
}

type OfferParams = 
{
	slug: string;
}

export const getStaticProps : GetStaticProps<OfferParams> = async ({params}) => {
	if(params === undefined) return { notFound: true };
	
	const offer = await apiBuild.get(`/offers/${params.slug}.json`);
	
	return {
		props: {
			...offer.data
		}
	};
}

export const getStaticPaths: GetStaticPaths = async () => {
	const offers = await apiBuild.get("/offers.json");
	
	const paths = offers.data.map((offer : Offer) => ({params: {slug: offer.slug}}));
	
	return { paths, fallback: false };
}

export default Offer;