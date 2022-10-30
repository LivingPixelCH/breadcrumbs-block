import { __ } from "@wordpress/i18n";
import {
	AlignmentToolbar,
	BlockControls,
	InspectorControls,
	useBlockProps,
} from "@wordpress/block-editor";
import {
	Panel,
	PanelBody,
	PanelRow,
	SelectControl,
} from "@wordpress/components";

import separatorOptions from "./options/separatorOptions";
import "./editor.scss";

export default function Edit({ attributes, setAttributes }) {
	const { textAlignment, separator } = attributes;

	const alignmentClass =
		textAlignment !== null ? "has-text-align-" + textAlignment : "";

	return (
		<>
			<InspectorControls key="breadcrumbs-settings">
				<Panel header={__("Breadcrumbs Settings")}>
					<PanelBody title={__("General", "breadcrumbs-block")}>
						<PanelRow>
							<SelectControl
								label={__("Separators", "breadcrumbs-block")}
								value={separator}
								options={separatorOptions}
								onChange={(separator) => setAttributes({ separator })}
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</InspectorControls>
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
