import React, { useState, useContext } from "react";
import { useForm, SubmitHandler } from "react-hook-form";
import AuthenticationContext from "../../services/AuthenticationContext";
import Api, { isApiException } from "../../services/Api";
import styles from "./login.module.scss";
import InputText from "../ui/inputText";
import InputCheckbox from "../ui/inputCheckbox";
import Modal from "../ui/modal";

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

type FormStatus = 
{
	status: "idle" | "waiting" | "error" | "logged";
	detail?: string;
}

const Login = ({className} : LoginProps) : JSX.Element =>
{
	const {setAuthenticated} = useContext(AuthenticationContext);
	const {register, handleSubmit, reset, setError, formState: {errors}} = useForm<LoginInputs>({});
	const [form, setForm] = useState<FormStatus>({status: "idle"});
	
	const loginRegisterConfig = {required: "Podaj numer pokoju, email, telefon:"};
	const passwordRegisterConfig = {required: "Podaj hasło:"};
	const rememberRegisterConfig = {};
	
	const loginSubmitHandler : SubmitHandler<LoginInputs> = async (data: LoginInputs) =>
	{
		try
		{
			setForm({status: "waiting"});
			const response = await Api.post("/token", data);
			if(response.status === 200)
			{
				setForm({status: "logged"});
				setAuthenticated(response.data.token);
				reset();
			}
		}
		catch(e: unknown)
		{
			if(isApiException(e))
			{
				if(e.response?.status === 401)
				{
					setForm({status: "error", detail: "Zły login albo hasło"});
					setError("login", {type: "manual", message: "Login jest niepoprawny:"});
					setError("password", {type: "manual", message: "Lub hasło jest niepoprawne:"});
					return;
				}
				setForm({status: "error", detail: e.message});
			}
		}
	}
	
	const disposeModalHandle = () =>
	{
		setForm({status: "idle"});
	}
	
	const stylesForm = [styles.form, className].join(" ");
	return (
		<form className={stylesForm} onSubmit={handleSubmit(loginSubmitHandler)}>
			<fieldset className={styles.inputs}>
				<Modal content={form.detail} visible={form.status == "error"} onClose={disposeModalHandle}/>
				<Modal content="Zalogowano do systemu." visible={form.status == "logged"} onClose={disposeModalHandle} />
				<InputText className={styles.login} type="text" label="Numer pokoju, email, telefon:" { ...register('login', loginRegisterConfig)} invalid={errors.login} />
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