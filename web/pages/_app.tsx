import '../styles/globals.scss';
import { useState } from 'react';
import type { AppProps } from 'next/app';
import LayoutBase from '../components/layoutBase';
import AuthenticationContext, {AuthenticationContextData} from '../services/AuthenticationContext';

function MyApp({ Component, pageProps }: AppProps) {
	const [isAuthenticated, setAuthenticated] = useState<AuthenticationContextData>(false);
	const AuthenticationContextValue = {isAuthenticated, setAuthenticated};
	
	return (
		<AuthenticationContext.Provider value={AuthenticationContextValue}>
			<LayoutBase>
				<Component {...pageProps} />
			</LayoutBase>
		</AuthenticationContext.Provider>
	)
}

export default MyApp;