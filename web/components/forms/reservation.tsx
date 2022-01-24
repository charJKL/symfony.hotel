import React, { InputHTMLAttributes} from "react";
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

const Reservation = () : JSX.Element => {
	const values: ReservationInputs = {peopleAmount: 1, roomsAmount: 1, contact: "", checkInAt: null, checkOutAt: null};
	const { register, handleSubmit, control, formState: {errors}} = useForm<ReservationInputs>({defaultValues: values});

	const peopleAmountRegisterConfig = {required: 'Ilość osób jest obowiązkowa:', min: 1, valueAsNumber: true};
	const roomsAmountRegisterConfig = {required: 'Ilość pokoi jest obowiązkowa:', min: 1, valueAsNumber: true};
	const contactRegisterConfig = {required: 'Musisz podać email lub telefon:'};
	const checkInAtRegisterConfig = {required: "Musisz podać przewidywaną datę przyjazdu:", valueAsDate: true };
	const checkOutAtRegisterConfig = {required: "Musisz podać przewidywaną datę wymeldowania:", valueAsDate: true};
	
	const handleReservation : SubmitHandler<ReservationInputs> = (data: ReservationInputs) =>
	{
		console.log(data);
		instance.post("/reservations", data)
			.then((r) => { console.log(r); })
			.catch((r) => { console.error(r); })
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
	return (
		<div className={styles.reservation}>
			<h1 className={styles.formHeader}>Dokonaj rezerwacji:</h1>
			<form className={styles.form} onSubmit={handleSubmit(handleReservation)}>
				<fieldset className={styles.fields}>
					<InputRef className={styles.peopleAmount} type="number" min="1" label="Ilość osób:" {...register('peopleAmount', peopleAmountRegisterConfig)} invalid={errors.peopleAmount} />
					<InputRef className={styles.roomsAmount} type="number" min="1" label="Ilość pokoi:" {...register('roomsAmount', roomsAmountRegisterConfig)} invalid={errors.roomsAmount} />
					<InputRef className={styles.contact} type="text" label="Email lub telefon:" {...register('contact', contactRegisterConfig)} invalid={errors.contact} />
					<InputRef className={styles.checkInAt} type="date" label="Przyjazd:" {...register('checkInAt', checkInAtRegisterConfig)} invalid={errors.checkInAt} />
					<InputRef className={styles.checkOutAt} type="date" label="Wymeldowanie:" {...register('checkOutAt', checkOutAtRegisterConfig)} invalid={errors.checkOutAt} />
				</fieldset>
				<fieldset className={styles.button}>
					<input className={styles.submit} value="Rezerwuj" type="submit" />
				</fieldset>
			</form>
		</div>
	)
}

export default Reservation;