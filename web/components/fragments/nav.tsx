import Link from "next/link";
import styles from "./nav.module.scss";

const Nav = () : JSX.Element =>
{
	return (
		<nav className={styles.nav} >
			<div className={styles.navDiv}>
				<Link href="/rooms">
					<a className={styles.navLink} >
						<div className={styles.navLinkMain} >Pokoje</div>
						<div className={styles.navLinkSub} >standard &amp; ceny</div>
					</a>
				</Link>
			</div>
			<div className={styles.navDiv}>
				<Link href="/conferences">
					<a className={styles.navLink} >
						<div className={styles.navLinkMain} >Konferencje</div>
						<div className={styles.navLinkSub} >infrastruktura &amp; dostępność</div>
					</a>
				</Link>
			</div>
			<div className={styles.navDiv}>
				<Link href="/recreation">
					<a className={styles.navLink} >
						<div className={styles.navLinkMain}>Rekreacja</div>
						<div className={styles.navLinkSub}>spa &amp; basen</div>
					</a>
				</Link>
			</div>
			<div className={styles.navDiv}>
				<Link href="/contact">
					<a className={styles.navLink} >
						<div className={styles.navLinkMain}>Kontakt</div>
						<div className={styles.navLinkSub}>mapa &amp; telefon</div>
					</a>
				</Link>
			</div>
		</nav>
	)
}

export default Nav;