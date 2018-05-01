import React from 'react';
import {render} from 'react-dom';

class Home extends React.Component {
    constructor (props) {
        super(props);
    }

    render () {
        return (
            <div>
                <blockquote className="blockquote text-center" style={{marginTop: 30 + 'px'}}>
                    <h1 className="mb-0">MyCryptool is working!</h1>
                    <footer className="blockquote-footer">nginx, PHP and mysql in cooperation with <cite title="Docker">Docker</cite></footer>
                </blockquote>

                <div className="text-center mt-5">
                    <figure className="figure meme-figure">
                        <img src={this.props.memeFile} className="figure-img img-fluid rounded img-thumbnail" />
                    </figure>
                </div>
            </div>
        );
    }
}

const container = document.getElementById('container');
render(<Home {...(container.dataset)}/>, container);
