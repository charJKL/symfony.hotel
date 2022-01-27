import react, { InputHTMLAttributes, forwardRef, ForwardedRef} from "react";
import { FieldError, UseFormRegister } from "react-hook-form";
import styles from "./inputCheckbox.module.scss";

type InputCheckboxCustomProps =
{
	text: string;
	label?: string;
	invalid?: FieldError;
}
type InputCheckboxNativeProps = Omit<InputHTMLAttributes<HTMLInputElement>, 'type'>;
type InputCheckboxProps = InputCheckboxCustomProps & InputCheckboxNativeProps;
type InputRefType<T> = InputCheckboxProps & ReturnType<UseFormRegister<T>>

const InputCheckbox = <T,>({className, label, name, text, onChange, onBlur, invalid, ...props}: InputRefType<T>, ref: ForwardedRef<HTMLInputElement> ): JSX.Element =>
{
	const isInvalid = invalid ? styles.invalid : '';
	const labelText = invalid ? invalid.message : label;
	const id = styles.outer + name;
	const stylesOuter = [styles.outer, className, isInvalid].join(' ');
	return (
		<div className={stylesOuter}>
			<span className={styles.label}>{ labelText }</span>
			<input className={styles.input} type="checkbox" {...props} id={id} ref={ref} onChange={onChange} onBlur={onBlur} />
			<label className={styles.text} htmlFor={id}>{ text }</label>
		</div>
	)
}

export default forwardRef(InputCheckbox);