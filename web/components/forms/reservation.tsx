import { style } from "@mui/system";
import React, { InputHTMLAttributes, useRef, useState } from "react";
import { ForwardedRef } from "react";
import { forwardRef } from "react";
import { useForm, Controller, SubmitHandler, UseFormRegister } from "react-hook-form";
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
}
type InputProps = InputPropsBase & InputHTMLAttributes<HTMLInputElement>;

const Reservation = () : JSX.Element => {
	const values: ReservationInputs = {peopleAmount: 1, roomsAmount: 1, contact: "", checkInAt: null, checkOutAt: null};
	const { register, handleSubmit, control, formState: {errors}} = useForm<ReservationInputs>({defaultValues: values});
	
	const handleReservation : SubmitHandler<ReservationInputs> = (data: ReservationInputs) =>
	{
		console.log(data);
		instance.post("/reservations", data)
			.then((r) => { console.log(r); })
			.catch((r) => { console.error(r); })
	}
	
	type InputRefType = InputProps & ReturnType<UseFormRegister<ReservationInputs>>
	const Input = ({className, label, type, name, onChange, onBlur}: InputRefType, ref: ForwardedRef<HTMLInputElement> ): JSX.Element =>
	{
		return (<div className={[styles.inputDiv, className].join(' ')}>
			<label className={styles.inputLabel}>{label}</label>
			<input className={styles.inputInput} ref={ref} type={type} name={name} onChange={onChange} onBlur={onBlur} />
		</div>);
	}
	const InputRef = forwardRef<HTMLInputElement, InputRefType>(Input);
	return (
		<div className={styles.reservation}>
			<h1 className={styles.formHeader}>Dokonaj rezerwacji:</h1>
			<form className={styles.form} onSubmit={handleSubmit(handleReservation)}>
				<fieldset className={styles.fields}>
					<InputRef className={styles.peopleAmount} type="number" min="1" label="Ilość osób:" required {...register('peopleAmount', {required: true, min: 1})} />
					<InputRef className={styles.roomsAmount} type="number" min="1" label="Ilość pokoi:" required {...register('roomsAmount', {required: true, min: 1})} />
					<InputRef className={styles.contact} type="text" label="Email lub telefon:" required {...register('contact', {required: true})} />
					<InputRef className={styles.checkInAt} type="date" label="Przyjazd:" required {...register('checkInAt', {required: true})} />
					<InputRef className={styles.checkOutAt} type="date" label="Wymeldowanie:" required {...register('checkOutAt', {required: true})} />
				</fieldset>
				<fieldset className={styles.button}>
					<input className={styles.submit} value="Rezerwuj" type="submit" />
				</fieldset>
			</form>
		</div>
	)
}

export default Reservation;