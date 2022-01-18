import { useFormik } from "formik";


const Reservation = () : JSX.Element => {
	const form = useFormik({
		
	});
	
	return (
		<form>
			<input name="peopleAmount" type="number"/>
			<input name="roomAmount" type="number"/>
			<input name="contact" type="text"/>
			<input name="checkInAt" type="date"/>
			<input name="checkInAt" type="date"/>
			
			<input type="submit" />
		</form>
	)
}

export default Reservation;