import styles from "./nav.module.scss";

const Nav = () : JSX.Element =>
{
	return (
		<nav className={styles.nav} >
			<div className={styles.navDiv}>
				<a className={styles.navLink} href="/rooms">
					<div className={styles.navLinkMain} >Pokoje</div>
					<div className={styles.navLinkSub} >standard &amp; ceny</div>
				</a>
			</div>
			<div className={styles.navDiv}>
				<a className={styles.navLink} href="/conferences">
					<div className={styles.navLinkMain} >Konferencje</div>
					<div className={styles.navLinkSub} >infrastruktura &amp; dostępność</div>
				</a>
			</div>
			<div className={styles.navDiv}>
				<a className={styles.navLink} href="/recreation">
					<div className={styles.navLinkMain}>Rekreacja</div>
					<div className={styles.navLinkSub}>spa &amp; basen</div>
				</a>
			</div>
			<div className={styles.navDiv}>
				<a className={styles.navLink} href="/contact">
					<div className={styles.navLinkMain}>Kontakt</div>
					<div className={styles.navLinkSub}>mapa &amp; telefon</div>
				</a>
			</div>
		</nav>
	)
}

export default Nav;