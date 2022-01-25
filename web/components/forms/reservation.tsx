import React, { InputHTMLAttributes, useState} from "react";
import { ForwardedRef } from "react";
import { forwardRef } from "react";
import { useForm, SubmitHandler, UseFormRegister, FieldError } from "react-hook-form";
import instance from "../../axios";
import styles from "./reservation.module.scss";
import Modal from "../ui/modal";

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
type FormStatus = 
{
	status: "idle" | "waiting" | "error" | "saved";
	detail?: string;
}

const Reservation = () : JSX.Element => 
{	
	const {register, handleSubmit, reset, formState: {errors}} = useForm<ReservationInputs>({});
	const [form, setForm] = useState<FormStatus>({status: "idle"});

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
			setForm({status: "waiting"});
			const response = await instance.post("/reservations", data);
			if(response.status === 201)
			{
				setForm({status: "saved"});
				reset();
			}
		}
		catch(e)
		{
			setForm({status: "error", detail: e});
		}
	}
	
	const disposeModalHandle = () =>
	{
		setForm({status: "idle"});
	}
	
	type InputRefType = InputProps & ReturnType<UseFormRegister<ReservationInputs>>
	const Input = ({className, label, onChange, onBlur, invalid, ...props}: InputRefType, ref: ForwardedRef<HTMLInputElement> ): JSX.Element =>
	{
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
	
	const Button = () : JSX.Element =>
	{
		switch(form.status)
		{
			case "idle": return <button className={styles.submit} type="submit">Rezerwuj</button>
			case "waiting": return <button className={styles.submit} type="submit"><img className={styles.waiting} src="/waiting.svg" /></button>
			case "error": return <button className={styles.submit} type="submit" disabled>Rezerwuj</button>
			case "saved": return <button className={styles.submit} type="submit" disabled>Rezerwuj</button>
		}
	}
	return (
		<div className={styles.reservation}>
			<h1 className={styles.formHeader}>Dokonaj rezerwacji:</h1>
			<form className={styles.form} onSubmit={handleSubmit(handleReservation)}>
				<fieldset className={styles.fields}>
					<Modal content={form.detail} visible={form.status == "error"} onClose={disposeModalHandle}/>
					<Modal content="Twoja rezerwacja została zapisana" visible={form.status == "saved"} onClose={disposeModalHandle} />
					<InputRef className={styles.peopleAmount} type="number" min="1" label="Ilość osób:" {...register('peopleAmount', peopleAmountRegisterConfig)} invalid={errors.peopleAmount} />
					<InputRef className={styles.roomsAmount} type="number" min="1" label="Ilość pokoi:" {...register('roomsAmount', roomsAmountRegisterConfig)} invalid={errors.roomsAmount} />
					<InputRef className={styles.contact} type="text" label="Email lub telefon:" {...register('contact', contactRegisterConfig)} invalid={errors.contact} />
					<InputRef className={styles.checkInAt} type="date" label="Przyjazd:" {...register('checkInAt', checkInAtRegisterConfig)} invalid={errors.checkInAt} />
					<InputRef className={styles.checkOutAt} type="date" label="Wymeldowanie:" {...register('checkOutAt', checkOutAtRegisterConfig)} invalid={errors.checkOutAt} />
				</fieldset>
				<fieldset className={styles.button}>
					{ <Button /> }
				</fieldset>
			</form>
		</div>
	)
}

export default Reservation;