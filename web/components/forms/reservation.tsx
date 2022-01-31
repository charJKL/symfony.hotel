import React, { useState} from "react";
import { useForm, SubmitHandler } from "react-hook-form";
import Api, { isApiException } from "../../services/Api";
import styles from "./reservation.module.scss";
import Modal from "../ui/modal";
import InputText from "../ui/inputText";

type ReservationInputs =
{
	peopleAmount: number;
	roomsAmount: number;
	contact: string;
	checkInAt: Date | null;
	checkOutAt: Date | null;
}

type FormStatus = 
{
	status: "idle" | "waiting" | "error" | "saved";
	detail?: string;
}

const Reservation = () : JSX.Element => 
{	
	const {register, handleSubmit, reset, setError, formState: {errors}} = useForm<ReservationInputs>({});
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
			const response = await Api.post("/reservations", data);
			if(response.status === 201)
			{
				setForm({status: "saved"});
				reset();
			}
		}
		catch(e: unknown)
		{
			if(isApiException(e))
			{
				if(e.response?.status === 422)
				{
					setForm({status: "error", detail: "Rezerwacja zawiera błędy, popraw wskazane pola."});
					for(const v of e.response.data.violations)
					{
						const error = {type: "manual", message: v.message};
						setError(v.propertyPath, error);
					}
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
					<InputText className={styles.peopleAmount} type="number" min="1" label="Ilość osób:" {...register('peopleAmount', peopleAmountRegisterConfig)} invalid={errors.peopleAmount} />
					<InputText className={styles.roomsAmount} type="number" min="1" label="Ilość pokoi:" {...register('roomsAmount', roomsAmountRegisterConfig)} invalid={errors.roomsAmount} />
					<InputText className={styles.contact} type="text" label="Email lub telefon:" {...register('contact', contactRegisterConfig)} invalid={errors.contact} />
					<InputText className={styles.checkInAt} type="date" label="Przyjazd:" {...register('checkInAt', checkInAtRegisterConfig)} invalid={errors.checkInAt} />
					<InputText className={styles.checkOutAt} type="date" label="Wymeldowanie:" {...register('checkOutAt', checkOutAtRegisterConfig)} invalid={errors.checkOutAt} />
				</fieldset>
				<fieldset className={styles.button}>
					{ <Button /> }
				</fieldset>
			</form>
		</div>
	)
}

export default Reservation;