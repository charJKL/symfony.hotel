import { useForm, SubmitHandler } from "react-hook-form";
import instance from "../../axios";

type ReservationInputs =
{
	peopleAmount: number;
	roomsAmount: number;
	contact: string;
	checkInAt: string;
	checkOutAt: string;
}

const Reservation = () : JSX.Element => {
	const { register, handleSubmit } = useForm<ReservationInputs>();
	
	const handleReservation = (data: ReservationInputs) =>
	{
		console.log(data);
		instance.post("/reservations", data)
			.then((r) => { console.log(r); })
			.catch((r) => { console.error(r); })
	}
	
	return (
		<form onSubmit={handleSubmit(handleReservation)}>
			<input type="number" {...register('peopleAmount', {required: true})} />
			<input type="number" {...register('roomsAmount', {required: true})} />
			<input type="text" {...register('contact', {required: true})} />
			<input type="date" {...register('checkInAt', {required: true})} />
			<input type="date" {...register('checkOutAt', {required: true})} />
			<input type="submit" />
		</form>
	)
}

export default Reservation;