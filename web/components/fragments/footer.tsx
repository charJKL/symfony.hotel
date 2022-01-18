import styles from "./footer.module.scss";

const Footer = () : JSX.Element =>
{
	return (
		<footer className={styles.footer}>
			<section className={styles.footerLeft}>
				<div>Hotel NoName</div>
				<div>© 2021</div>
			</section>
			<img className={styles.footerLogo} src="/logo_small.png" alt="Small logo in footer"/>
			<section className={styles.footerRight}>
				<div>ul. Ulica 23</div>
				<div>00-000 Kraków, Polska</div>
				<div>tel. +48 00 000 00 00</div>
			</section>
		</footer>
	)
}

export default Footer;
