import react, { useContext } from "react";
import AuthenticationContext from "../../services/AuthenticationContext";
import Login from "../forms/login";
import styles from "./header.module.scss";

const Header = () : JSX.Element =>
{
	const {isAuthenticated, setAuthenticated} = useContext(AuthenticationContext);

	return (
		<header className={styles.header} >
			<a className={styles.headerLink} href="/">
				<img src="/logo.png" alt="logo" />
			</a>
			<Login />
		</header>
	)
}

export default Header;
