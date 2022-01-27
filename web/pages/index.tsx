import type { NextPage, GetStaticProps } from 'next'
import Reservation from '../components/forms/reservation'
import instance from "../services/axios";
import apiBuild from "../services/ApiBuild";

type Offer =
{
	id: number;
	name: number;
	description: string;
	image: string;
}

type IndexProps = 
{
	offers: Offer[]
}

const Index = ({offers} : IndexProps) : JSX.Element => {
	
	const Offer = ({id, name, description, image} : Offer) =>
	{
		return (<div>{name}</div>)
	}
	console.log(offers);
	return (
		<>
			<Reservation/>
			<section>
				{offers.map(offer => <Offer {...offer} />)}
			</section>
		</>
	)
}

export const getStaticProps : GetStaticProps = async (context) => {
	const offers = await apiBuild.get("/offers.json");
	
	return {
		props: {
			offers: offers.data
		}
	};
}


export default Index;