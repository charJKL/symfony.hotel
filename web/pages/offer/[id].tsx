import type { NextPage, GetStaticProps, GetStaticPaths } from 'next'
import apiBuild from "../../services/ApiBuild";
import type Offer from "../../entities/Offer";

type OfferProps = Offer;

const Offer = ({id, name, description} : OfferProps) => {
	return (
		<div>
			<h1>{ name }</h1>
			<p>{ description }</p>
		</div>
	);
}

type OfferParams = 
{
	id: string;
}

export const getStaticProps : GetStaticProps<OfferParams> = async ({params}) => {
	if(params === undefined) return { notFound: true };
	
	const offer = await apiBuild.get(`/offers/${params.id}.json`);
	
	return {
		props: {
			...offer.data
		}
	};
}

export const getStaticPaths: GetStaticPaths = async () => {
	const offers = await apiBuild.get("/offers.json");
	
	const paths = offers.data.map((offer : Offer) => ({params: {id: offer.id.toString()}}));
	
	return { paths, fallback: false };
}

export default Offer;