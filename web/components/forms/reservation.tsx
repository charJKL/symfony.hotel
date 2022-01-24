import React, { InputHTMLAttributes, useState} from "react";
import { ForwardedRef } from "react";
import { forwardRef } from "react";
import { useForm, SubmitHandler, UseFormRegister, FieldError } from "react-hook-form";
import instance from "../../axios";
import styles from "./reservation.module.scss";

type ReservationInputs =
{
	peopleAmount: number;
	roomsAmount: number;
	contact: string;
	checkInAt: Date | null;
	checkOutAt: Date | null;
}

type InputPropsBase = 
{
	label?: string;
	invalid?: FieldError;
}
type InputProps = InputPropsBase & InputHTMLAttributes<HTMLInputElement>;

const Reservation = () : JSX.Element => 
{	
	const {register, handleSubmit, control, formState: {errors}} = useForm<ReservationInputs>({});
	const [isWaititng, setWaiting] = useState<boolean>(false);
	const [wasError, setError] = useState<string>("asd");
	const [wasSuccess, setSuccess] = useState<boolean>(false);

	const peopleAmountRegisterConfig = {required: 'Ilość osób jest obowiązkowa:', min: 1, valueAsNumber: true};
	const roomsAmountRegisterConfig = {required: 'Ilość pokoi jest obowiązkowa:', min: 1, valueAsNumber: true};
	const contactRegisterConfig = {required: 'Musisz podać email lub telefon:'};
	const checkInAtRegisterConfig = {required: "Musisz podać przewidywaną datę przyjazdu:"};
	const checkOutAtRegisterConfig = {required: "Musisz podać przewidywaną datę wymeldowania:"};
	
	const handleReservation : SubmitHandler<ReservationInputs> = async (data: ReservationInputs) =>
	{
		console.log(data);
		try
		{
			setWaiting(true);
			const response = await instance.post("/reservations", data);
			if(response.status === 201)
			{
				setSuccess(true);
			}
		}
		catch(e)
		{
			setError(e);
		}
		finally
		{
			setWaiting(false);
		}
	}
	
	const closeResponseHandler = () =>
	{
		setError("");
		setSuccess(false);
	}
	
	type InputRefType = InputProps & ReturnType<UseFormRegister<ReservationInputs>>
	const Input = ({className, label, onChange, onBlur, invalid, ...props}: InputRefType, ref: ForwardedRef<HTMLInputElement> ): JSX.Element =>
	{
		console.log(invalid);
		const isInvalid = invalid != undefined ? styles.invalid : '';
		const text = invalid != undefined ? invalid.message : label;
		const styleDiv = [styles.inputDiv, className, isInvalid].join(' ');
		const styleLabel = [styles.inputLabel, isInvalid].join(' ');
		const styleInput = [styles.inputInput, isInvalid].join(' ');
		return (<div className={styleDiv}>
			<label className={styleLabel}>{text}</label>
			<input className={styleInput} {...props} ref={ref} onChange={onChange} onBlur={onBlur} />
		</div>);
	}
	
	const InputRef = forwardRef<HTMLInputElement, InputRefType>(Input);
	const errorMessage = wasError ? <ErrorElement message={wasError} dispose={closeResponseHandler}/> : null;
	const successMessage = wasSuccess ? <SuccesElement dispose={closeResponseHandler}/> : null;
	const button = isWaititng ? <img className={styles.waiting} src="/waiting.svg" /> : 'Rezerwuj';
	return (
		<div className={styles.reservation}>
			<h1 className={styles.formHeader}>Dokonaj rezerwacji:</h1>
			<form className={styles.form} onSubmit={handleSubmit(handleReservation)}>
				<fieldset className={styles.fields}>
					{errorMessage}
					{successMessage}
					<InputRef className={styles.peopleAmount} type="number" min="1" label="Ilość osób:" {...register('peopleAmount', peopleAmountRegisterConfig)} invalid={errors.peopleAmount} />
					<InputRef className={styles.roomsAmount} type="number" min="1" label="Ilość pokoi:" {...register('roomsAmount', roomsAmountRegisterConfig)} invalid={errors.roomsAmount} />
					<InputRef className={styles.contact} type="text" label="Email lub telefon:" {...register('contact', contactRegisterConfig)} invalid={errors.contact} />
					<InputRef className={styles.checkInAt} type="date" label="Przyjazd:" {...register('checkInAt', checkInAtRegisterConfig)} invalid={errors.checkInAt} />
					<InputRef className={styles.checkOutAt} type="date" label="Wymeldowanie:" {...register('checkOutAt', checkOutAtRegisterConfig)} invalid={errors.checkOutAt} />
				</fieldset>
				<fieldset className={styles.button}>
					<button className={styles.submit} type="submit">
						{button}
					</button>
				</fieldset>
			</form>
		</div>
	)
}

type ErrorElementProps =
{
	message: string;
	dispose: () => void;
}
const ErrorElement = ({message, dispose}: ErrorElementProps) : JSX.Element =>
{
	return (
		<div className={styles.error}>
			<p>{message}</p>
			<button onClick={dispose}>Spróbuje ponownie.</button>
		</div>
	)
}

type SuccessElementProps =
{
	dispose: () => void;
}
const SuccesElement = ({dispose}: SuccessElementProps) : JSX.Element =>
{
	return (
		<div className={styles.success}>
			<p>Rezerwacja zostałą zapisana. Skontaktujemy się z panią.</p>
			<button onClick={dispose}>Rozumiem, dziękuje.</button>
		</div>
	)
}


export default Reservation;