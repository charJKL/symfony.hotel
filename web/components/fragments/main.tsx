import styles from "./main.module.scss";

type MainProps =
{
	children: React.ReactNode;
}

const Main = ({children} : MainProps) : JSX.Element =>
{
	return (
		<main className={styles.main} >
			{children}
		</main>
	)
}

export default Main;