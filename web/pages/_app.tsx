import '../styles/globals.scss'
import type { AppProps } from 'next/app'
import LayoutBase from '../components/layoutBase';

function MyApp({ Component, pageProps }: AppProps) {
	return (
		<LayoutBase>
			<Component {...pageProps} />
		</LayoutBase>
	)
}

export default MyApp
