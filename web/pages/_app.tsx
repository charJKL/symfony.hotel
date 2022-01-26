import '../styles/globals.scss';
import { useState } from 'react';
import type { AppProps } from 'next/app';
import LayoutBase from '../components/layoutBase';
import AuthenticationContext, {AuthenticationContextData} from '../services/AuthenticationContext';


// Redecalare forwardRef
// https://react-typescript-cheatsheet.netlify.app/docs/basic/getting-started/forward_and_create_ref#option-2---redeclare-forwardref
declare module "react" {
  function forwardRef<T, P = {}>(
    render: (props: P, ref: React.Ref<T>) => React.ReactElement | null
  ): (props: P & React.RefAttributes<T>) => React.ReactElement | null;
}

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