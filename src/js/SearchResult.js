import React from 'react'; 
import {decode} from 'html-entities';
export default class SearchResult extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <li className="result">
                <a href={this.props.result.url}>{decode(this.props.result.title)}</a>
            </li>
        )
    }
}