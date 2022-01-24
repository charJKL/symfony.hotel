import '../styles/globals.scss';
import type { AppProps } from 'next/app';
import LayoutBase from '../components/layoutBase';
import '@fontsource/roboto/300.css';
import '@fontsource/roboto/400.css';
import '@fontsource/roboto/500.css';
import '@fontsource/roboto/700.css';

function MyApp({ Component, pageProps }: AppProps) {
	return (
		<LayoutBase>
			<Component {...pageProps} />
		</LayoutBase>
	)
}

export default MyApp
