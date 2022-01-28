import Link from "next/link";
import react from "react";
import styles from "./header.module.scss";

const Header = () : JSX.Element =>
{
	return (
		<header className={styles.header} >
			<Link href="/">
			<a className={styles.headerLink}>
				<img src="/logo.png" alt="logo" />
			</a>
			</Link>
		</header>
	)
}

export default Header;
