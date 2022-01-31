import { createContext, Dispatch, SetStateAction } from "react";

type AuthenticationContextData = string;
type AuthenticationContextType = 
{
	isAuthenticated: AuthenticationContextData;
	setAuthenticated: Dispatch<SetStateAction<AuthenticationContextData>>;
}

const AuthenticationContextDefault = 
{
	isAuthenticated: "",
	setAuthenticated: () => {}
}

const AuthenticationContext = createContext<AuthenticationContextType>(AuthenticationContextDefault);

export type { AuthenticationContextData };
export default AuthenticationContext;