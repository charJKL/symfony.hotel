import styles from "./authentication.module.scss";
import Login from "../forms/login";

const Authentication = () : JSX.Element =>
{
	return (
		<div className={styles.authentication}>
			<Login />
		</div>
	)
}

export default Authentication;