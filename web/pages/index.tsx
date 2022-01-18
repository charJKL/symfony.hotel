import type { NextPage } from 'next'
import Head from 'next/head'
import Image from 'next/image'
import styles from '../styles/Home.module.scss'

const Home: NextPage = () => {
	return (
		<>
			<Head>
				<title>Create Next App</title>
				<meta name="description" content="Generated by create next app" />
				<link rel="icon" href="/favicon.ico" />
			</Head>
			
			<form>
				<input type="text" name="checkInAt" value="checkInAt" />
				<input type="text" name="checkInAt" value="checkInAt" />
				<input type="text" name="checkInAt" value="checkInAt" />
				<input type="text" name="checkInAt" value="checkInAt" />
			</form>
		</>
	)
}

export default Home