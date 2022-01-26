import { type } from "node:os";
import { createContext, Dispatch, SetStateAction } from "react";

type AuthenticationContextData = boolean;
type AuthenticationContextType = 
{
	isAuthenticated: AuthenticationContextData;
	setAuthenticated: Dispatch<SetStateAction<AuthenticationContextData>>;
}

const AuthenticationContextDefault = 
{
	isAuthenticated: false,
	setAuthenticated: () => {}
}

const AuthenticationContext = createContext<AuthenticationContextType>(AuthenticationContextDefault);

export type { AuthenticationContextData };
export default AuthenticationContext;