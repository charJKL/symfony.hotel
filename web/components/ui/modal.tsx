import { string } from "prop-types"
import React, { useState } from "react"
import styles from "./modal.module.scss"

type ModalProps =
{
	content?: string;
	button?: string;
	visible: boolean;
	onClose?: () => void;
}

const Modal = ({content, visible, button = "Okey", onClose} : ModalProps) : JSX.Element =>
{
	const visibility = visible ? 'visible' : 'hidden';
	return (
		<div className={styles.modal} style={{visibility: visibility}}>
			<button className={styles.close} type="button" onClick={onClose}>╳</button>
			<button className={styles.button} type="button" onClick={onClose} >{button}</button>
			<div className={styles.content}>{content}</div>
		</div>
	);
}

export default Modal;