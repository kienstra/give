/**
 * External dependencies
 */
import { isUndefined } from 'lodash';

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { withSelect } = wp.data;
const { SelectControl, Button } = wp.components;

/**
 * Internal dependencies
 */
import { getSiteUrl } from '../../utils';
import GiveBlankSlate from '../blank-slate';
import NoForms from '../no-form';

/**
 * Render form select UI
 */
const giveFormOptionsDefault = { value: '0', label: __( '-- Select Form --' ) };

const SelectForm = ( { forms, attributes, setAttributes } ) => {
	//Attributes
	const { prevId } = attributes;

	// Event(s)
	const getFormOptions = () => {
		// Add API Data To Select Options

		let formOptions = [];

		if ( ! isUndefined( forms ) ) {
			formOptions = forms.map(
				( { id, title: { rendered: title } } ) => {
					return {
						value: id,
						label: title === '' ? `${ id } : ${ __( 'No form title' ) }` : title,
					};
				}
			);
		}
		// Add Default option
		formOptions.unshift( giveFormOptionsDefault );

		return formOptions;
	};

	const setFormIdTo = id => {
		setAttributes( { id: Number( id ) } );
	};

	const resetFormIdTo = () => {
		setAttributes( { id: Number( prevId ) } );
		setAttributes( { prevId: undefined } );
	};

	// Render Component UI
	let componentUI;

	if ( ! forms ) {
		componentUI = <GiveBlankSlate title={ __( 'Loading...' ) } isLoader={ true } />;
	} else if ( forms && forms.length === 0 ) {
		componentUI = <NoForms />;
	} else {
		componentUI = (
			<GiveBlankSlate title={ __( 'Give Donation form' ) }>
				<SelectControl
					options={ getFormOptions() }
					onChange={ setFormIdTo }
				/>

				<Button isPrimary
					isLarge href={ `${ getSiteUrl() }/wp-admin/post-new.php?post_type=give_forms` }>
					{ __( 'Add New Form' ) }
				</Button>&nbsp;&nbsp;

				{
					prevId &&
					<Button isLarge
						onClick={ resetFormIdTo }>
						{ __( 'Cancel' ) }
					</Button>
				}
			</GiveBlankSlate>
		);
	}

	return componentUI;
};

/**
 * Export with forms data
 */
export default withSelect( ( select ) => {
	return {
		forms: select( 'core' ).getEntityRecords( 'postType', 'give_forms' ),
	};
} )( SelectForm );
