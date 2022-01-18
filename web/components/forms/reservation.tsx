import { useFormik } from "formik";
import axios from 'axios';

type FormInputs =
{
	peopleAmount: number;
	roomAmount: number;
	contact: string;
	checkInAt: string;
	checkOutAt: string;
}

const Reservation = () : JSX.Element => {
	const form = useFormik({
		initialValues: {
			peopleAmount: 0,
			roomsAmount: 0,
			contact: "",
			checkInAt: "",
			checkOutAt: "",
		},
		onSubmit: (values) => {
			console.log(values);
			axios.post("http://localhost:8000/api/reservations", values)
				.then((r) => { console.log(r); })
				.catch((r) => { console.error(r); })
		}
	});
	
	return (
		<form onSubmit={form.handleSubmit}>
			<input name="peopleAmount" type="number" onChange={form.handleChange} value={form.values.peopleAmount} />
			<input name="roomsAmount" type="number" onChange={form.handleChange} value={form.values.roomsAmount} />
			<input name="contact" type="text" onChange={form.handleChange} value={form.values.contact} />
			<input name="checkInAt" type="date" onChange={form.handleChange} value={form.values.checkInAt} />
			<input name="checkOutAt" type="date" onChange={form.handleChange} value={form.values.checkOutAt} />
			<input type="submit" />
		</form>
	)
}

export default Reservation;