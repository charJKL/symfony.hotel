import react, { InputHTMLAttributes, forwardRef, ForwardedRef} from "react";
import { FieldError, UseFormRegister } from "react-hook-form";
import styles from "./inputText.module.scss";

type InputTextCustomProps =
{
	label?: string;
	invalid?: FieldError;
	type: "text" | "number" | "date" | "password";
}
type InputTextNativeProps = Omit<InputHTMLAttributes<HTMLInputElement>, 'type'>;
type InputTextProps = InputTextCustomProps & InputTextNativeProps;
type InputRefType<T> = InputTextProps & ReturnType<UseFormRegister<T>>

const InputText = <T,>({className, label, type = 'text', onChange, onBlur, invalid, ...props}: InputRefType<T>, ref: ForwardedRef<HTMLInputElement> ): JSX.Element =>
{
	const isInvalid = invalid ? styles.invalid : '';
	const labelText = invalid ? invalid.message : label;

	const stylesOuter = [styles.outer, className, isInvalid].join(' ');
	return (
		<div className={stylesOuter}>
			<label className={styles.label}>{ labelText }</label>
			<input className={styles.input} type={type} {...props} ref={ref} onChange={onChange} onBlur={onBlur} />
		</div>
	)
}

export default forwardRef(InputText);