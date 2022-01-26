import react, { InputHTMLAttributes, forwardRef, ForwardedRef} from "react";
import { FieldError, UseFormRegister } from "react-hook-form";
import styles from "./input.module.scss";

type InputPropsBase = 
{
	label?: string;
	invalid?: FieldError;
}
type InputProps = InputPropsBase & InputHTMLAttributes<HTMLInputElement>;
type InputRefType<T> = InputProps & ReturnType<UseFormRegister<T>>

const Input = <T,>({className, label, onChange, onBlur, invalid, ...props}: InputRefType<T>, ref: ForwardedRef<HTMLInputElement> ): JSX.Element =>
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

export default forwardRef(Input);