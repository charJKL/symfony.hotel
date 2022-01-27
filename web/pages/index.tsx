import type { NextPage, GetStaticProps } from 'next'
import Link from 'next/link'
import Reservation from '../components/forms/reservation'
import apiBuild from "../services/ApiBuild";
import type Offer from "../entities/Offer";
import styles from "./index.module.scss";

type IndexProps = 
{
	offers: Offer[]
}

const Index : NextPage<IndexProps> = ({offers} : IndexProps) : JSX.Element => {
	
	const Offer = ({id, name, description, image} : Offer) =>
	{
		return (
			<Link href={`offer/${id}`} >
				<a className={styles.offer}>
					<img className={styles.image} src={`http://localhost:8000/${image}`} />
					<h1 className={styles.name}>{ name }</h1>
				</a>
			</Link>
		)
	}
	return (
		<>
			<Reservation/>
			<section className={styles.offers}>
				{offers.map(offer => <Offer key={offer.id} {...offer} />)}
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