import Link from "next/link";
import styles from "./services.module.scss";


const Services = () : JSX.Element =>
{
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
		</nav>
	)
}

export default Services;