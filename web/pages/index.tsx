import type { NextPage, GetStaticProps, GetStaticPaths } from 'next'
import Link from 'next/link'
import Reservation from '../components/forms/reservation'
import apiBuild from "../services/ApiBuild";
import type Offer from "../entities/Offer";

type IndexProps = 
{
	offers: Offer[]
}

const Index = ({offers} : IndexProps) : JSX.Element => {
	
	const Offer = ({id, name, description, image} : Offer) =>
	{
		return (
			<div>
				<Link href={`offer/${id}`} ><a>{name}</a></Link>
			</div>
		)
	}
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