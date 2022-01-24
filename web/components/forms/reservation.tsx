import React, { useRef, useState } from "react";
import { useForm, Controller, SubmitHandler, ControllerRenderProps } from "react-hook-form";
import instance from "../../axios";
import styles from "./reservation.module.scss";

import DateAdapter from '@mui/lab/AdapterDayjs';
import LocalizationProvider from '@mui/lab/LocalizationProvider';
import pl_PL from "dayjs/locale/pl";
import DateRangePicker, { DateRange } from '@mui/lab/DateRangePicker';
import TextField from '@mui/material/TextField';
import { MuiTextFieldProps } from "@mui/lab/internal/pickers/PureDateInput";

type ReservationInputs =
{
	peopleAmount: number;
	roomsAmount: number;
	contact: string;
	range: DateRange<Date>;
}

const Reservation = () : JSX.Element => {
	const values: ReservationInputs = {peopleAmount: 1, roomsAmount: 1, contact: "", range: [null, null]};
	const { register, handleSubmit, control, formState: {errors}} = useForm<ReservationInputs>({defaultValues: values});
	
	const handleReservation : SubmitHandler<ReservationInputs> = (data: ReservationInputs) =>
	{
		console.log(data);
		instance.post("/reservations", data)
			.then((r) => { console.log(r); })
			.catch((r) => { console.error(r); })
	}
	
	const [value, setValue] = React.useState<DateRange<Date>>([null, null]);
	//<input type="date" {...register('checkInAt', {required: true})} />
	//<input type="date" {...register('checkOutAt', {required: true})} />
	// { errors.peopleAmount && <span>Invalid people amount</span>}
	
	const dateRangePickerInputs = (startProps : MuiTextFieldProps, endProps: MuiTextFieldProps) => (
		<React.Fragment>
			<TextField variant="filled" {...startProps} />
			<TextField variant="filled" {...endProps} />
		</React.Fragment> )
	const dateRangePicker = ({value, ref, onChange}: ControllerRenderProps<ReservationInputs, "range">) => (
		<DateRangePicker className="XXXXXXXXXXXXXXXXXXXX" startText="Przyjazd:" endText="Wyjazd:" mask="mm.dd.yyyy" renderInput={dateRangePickerInputs} value={value} onChange={value => onChange(value)} inputRef={ref}/>
	)
	
	return (
		<div className={styles.reservation}>
			<h1 className={styles.formHeader}>Dokonaj rezerwacji:</h1>
			<form className={styles.form} onSubmit={handleSubmit(handleReservation)}>
				<fieldset className={styles.fields}>
					<TextField className={styles.peopleAmount} variant="filled" label="Ilość osób:" placeholder="1" type="number" min="1" required {...register('peopleAmount', {required: true, min: 1, max: 5})} />
					<TextField className={styles.roomsAmount} variant="filled" label="Ilość pokoi:" type="number" min="1" required {...register('roomsAmount', {required: true})} />
					<TextField className={styles.contact} variant="filled" label="Email lub telefon:" type="text" required {...register('contact', {required: true})} />
					<LocalizationProvider dateAdapter={DateAdapter} locale={pl_PL}>
						<Controller name="range" control={control} rules={{ required: true }} render={({field}) => dateRangePicker(field) } />
					</LocalizationProvider>
				</fieldset>
				<fieldset className={styles.button}>
					<input className={styles.submit} value="Rezerwuj" type="submit" />
				</fieldset>
			</form>
		</div>
	)
}

export default Reservation;