import React, { useState} from "react";
import { useForm, SubmitHandler } from "react-hook-form";
import instance from "../../services/axios";
import styles from "./login.module.scss";
import InputText from "../ui/inputText";
import InputCheckbox from "../ui/inputCheckbox";

type LoginInputs =
{
	login: string;
	password: string;
	remember: boolean;
}

type LoginProps =
{
	className?: string;
}

const Login = ({className} : LoginProps) : JSX.Element =>
{
	const {register, handleSubmit, reset, setError, formState: {errors}} = useForm<LoginInputs>({});
	//const [form, setForm] = useState<FormStatus>({status: "idle"});
	
	const loginRegisterConfig = {required: "Podaj numer pokoju, email, telefon:"};
	const passwordRegisterConfig = {required: "Podaj hasło:"};
	const rememberRegisterConfig = {};
	
	const loginSubmitHandler : SubmitHandler<LoginInputs> = async (data: LoginInputs) =>
	{
		console.log(data);
	}
	
	const stylesForm = [styles.form, className].join(" ");
	return (
		<form className={stylesForm} onSubmit={handleSubmit(loginSubmitHandler)}>
			<fieldset className={styles.inputs}>
				<InputText className={styles.login} label="Numer pokoju, email, telefon:" { ...register('login', loginRegisterConfig)} invalid={errors.login} />
				<InputText className={styles.password} type="password" label="Hasło:" { ...register('password', passwordRegisterConfig)} invalid={errors.password} />
				<InputCheckbox className={styles.remember} label="Zapamiętać logowanie?" text="Tak, zapamiętaj mnie." { ...register('remember', rememberRegisterConfig)} />
			</fieldset>
			<fieldset className={styles.button}>
				<button className={styles.submit}>Zaloguj</button>
			</fieldset>
		</form>
	)
}

export default Login;