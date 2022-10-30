import { __ } from "@wordpress/i18n";
import {
	useBlockProps,
	BlockControls,
	AlignmentToolbar,
} from "@wordpress/block-editor";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
	const { textAlignment } = attributes;

	const alignmentClass =
		textAlignment !== null ? "has-text-align-" + textAlignment : "";

	return (
		<>
			<BlockControls>
				<AlignmentToolbar
					value={textAlignment}
					onChange={(textAlignment) => setAttributes({ textAlignment })}
				/>
			</BlockControls>
			<div
				{...useBlockProps({
					className: alignmentClass,
				})}
			>
				{__("Breadcrumbs Block – hello from the editor!", "breadcrumbs-block")}
			</div>
		</>
	);
}
