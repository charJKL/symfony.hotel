import { useState, createContext, useEffect} from "react";

const LOCAL_STORAGE_TOKEN_KEY = "token_key";

type AuthenticationContextData = string;
type AuthenticationContextType = 
{
	isAuthenticated: AuthenticationContextData;
	setAuthenticated: (token: AuthenticationContextData) => void;
	deleteAuthentitation: () => void;
}
const AuthenticationContextDefault = { isAuthenticated: "", setAuthenticated: () => {}, deleteAuthentitation: () => {} };
const AuthenticationContext = createContext<AuthenticationContextType>(AuthenticationContextDefault);
	
const useAuthenticationService = () =>
{
	const [isAuthenticated, setAuthenticatedToken] = useState<AuthenticationContextData>("");

	const setAuthenticated = (token: AuthenticationContextData) =>
	{
		localStorage.setItem(LOCAL_STORAGE_TOKEN_KEY, token);
		setAuthenticatedToken(token);
	}
	
	const deleteAuthentitation = () => 
	{
		localStorage.removeItem(LOCAL_STORAGE_TOKEN_KEY);
		setAuthenticatedToken("");
	}
	
	useEffect(() =>{
		const token = localStorage === undefined ? "" : localStorage.getItem(LOCAL_STORAGE_TOKEN_KEY) ?? "" ;
		setAuthenticated(token);
	}, []);
	
	return {isAuthenticated, setAuthenticated, deleteAuthentitation}
}

export { AuthenticationContext };
export default useAuthenticationService;