import Link from "next/link";
import { useContext } from "react";
import { AuthenticationContext } from "../../services/useAuthenticationService";
import styles from "./services.module.scss";


const Services = () : JSX.Element =>
{
	const {deleteAuthentitation} = useContext(AuthenticationContext);
	
	const handleLogout = () =>
	{
		deleteAuthentitation();
	}
	
	return (
		<nav className={styles.nav} >
			<div className={styles.navDiv}>
				<Link href="/room-service">
					<a className={styles.navLink}>
						<div className={styles.navLinkMain} >Obsługa pokoju</div>
					</a>
				</Link>
			</div>
			<div className={styles.navDiv}>
				<Link href="/invoice">
					<a className={styles.navLink}>
						<div className={styles.navLinkMain} >Podsumowanie</div>
					</a>
				</Link>
			</div>
			<div className={styles.navDiv}>
				<Link href="/accommodation">
					<a className={styles.navLink}>
						<div className={styles.navLinkMain} >Transport</div>
					</a>
				</Link>
			</div>
			<div className={styles.navDiv}>
				<Link href="/spa-fitness">
					<a className={styles.navLink}>
						<div className={styles.navLinkMain} >Spa &amp; fitness</div>
					</a>
				</Link>
			</div>
			<div className={styles.navDiv}>
				<Link href="/laundry">
					<a className={styles.navLink}>
						<div className={styles.navLinkMain} >Pranie</div>
					</a>
				</Link>
			</div>
			<div className={styles.navDiv}>
				<Link href="/waking-up">
					<a className={styles.navLink}>
						<div className={styles.navLinkMain} >Budzik</div>
					</a>
				</Link>
			</div>
			<div className={styles.navDiv}>
					<a className={styles.navLink} href="#" onClick={handleLogout}>
						<div className={styles.navLinkMain} >Wyloguj</div>
					</a>
			</div>
		</nav>
	)
}

export default Services;