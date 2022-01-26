import React, { useState} from "react";
import { useForm, SubmitHandler } from "react-hook-form";
import instance from "../../axios";
import styles from "./login.module.scss";
import Input from "../ui/input";

type LoginInputs =
{
	login: string;
	password: string;
	remember: boolean;
}

const Login = () : JSX.Element =>
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
	
	return (
		<form className={styles.form} onSubmit={handleSubmit(loginSubmitHandler)}>
			<Input className={styles.login} type="text" label="Numer pokoju, email, telefon:" { ...register('login', loginRegisterConfig)} invalid={errors.login} />
			<Input className={styles.form} type="password" label="Hasło:" { ...register('password', passwordRegisterConfig)} invalid={errors.password} />
			<Input className={styles.rememberMe} type="checkbox" label="Zapamiętaj mnie" { ...register('remember', rememberRegisterConfig)} />
			<button>Zaloguj</button>
		</form>
	)
}

export default Login;