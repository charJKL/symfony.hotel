import styles from "./header.module.scss";

const Header = () : JSX.Element =>
{
	return (
		<header className={styles.header} >
			<a className={styles.headerLink} href="/">
				<img src="/logo.png" alt="logo" />
			</a>
		</header>
	)
}

export default Header;
