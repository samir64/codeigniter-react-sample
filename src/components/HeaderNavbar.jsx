import React from 'react';
import { BASE_URL } from '../util/constants';
import { Navbar, Nav, NavDropdown } from 'react-bootstrap';

export default class HeaderNavbar extends React.Component {
  render() {
    return (
      <Navbar bg="light" expand="lg">
        <Navbar.Brand href="#home" className="ms-sm-4">
          Dashboard
        </Navbar.Brand>
        <Navbar.Toggle aria-controls="basic-navbar-nav" />
        <Navbar.Collapse id="basic-navbar-nav">
          <Nav className="mx-sm-4">
            <Nav.Link
              href={this.props.page === 'project_list' ? '#' : '/dashboard'}
              className={this.props.page === 'project_list' ? 'active' : ''}
            >
              Project List
            </Nav.Link>
            <Nav.Link
              href={this.props.page === 'project_new' ? '#' : '/project/new'}
              className={this.props.page === 'project_new' ? 'active' : ''}
            >
              New Project
            </Nav.Link>
          </Nav>
          <Nav className="ms-sm-4">
            <svg
              className="profile-icon"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 128 128"
            >
              <path d="M79.9 83.8C74.8 82 69.5 81 64 81c0 0 0 0 0 0s0 0 0 0c-16.4 0-31.6 8.9-39.7 23.1-.8 1.4-.3 3.3 1.1 4.1.5.3 1 .4 1.5.4 1 0 2.1-.5 2.6-1.5C36.6 94.7 49.8 87 64 87c0 0 0 0 0 0s0 0 0 0c4.7 0 9.4.8 13.8 2.5.3.1.7.2 1 .2 1.2 0 2.4-.7 2.8-2C82.2 86.1 81.4 84.4 79.9 83.8zM64 27c-12.7 0-23 10.3-23 23s10.3 23 23 23 23-10.3 23-23S76.7 27 64 27zM64 67c-9.4 0-17-7.6-17-17s7.6-17 17-17 17 7.6 17 17S73.4 67 64 67zM121.9 97.6c-.5.5-1 1.1-1.6 1.8-4.4 5-12 13.5-12 13.5-.6.6-1.4 1-2.2 1 0 0 0 0-.1 0-.9 0-1.7-.4-2.3-1.2l-6.9-8.9c-.9-1.1-.9-2.8 0-3.9 1.3-1.5 3.5-1.4 4.6.1l4.8 6.2c0 0 7.3-8.2 11.1-12.5.3-.4.6-.7.9-1 .8-.9.7-2.2-.3-2.9-3.7-2.7-8.3-4.2-13.2-3.9-10 .7-18.2 8.9-18.6 19-.6 11.8 9.1 21.5 21 20.9 10-.5 18.2-8.5 19-18.4.3-3.4-.3-6.7-1.6-9.6C123.9 97 122.6 96.8 121.9 97.6z"></path>
            </svg>
            <NavDropdown
              title={`${this.props.firstname} ${this.props.lastname}`}
              id="basic-nav-dropdown"
            >
              <NavDropdown.Item disabled>{this.props.email}</NavDropdown.Item>
              <NavDropdown.Divider />
              <NavDropdown.Item href="/logout">Logout</NavDropdown.Item>
            </NavDropdown>
          </Nav>
        </Navbar.Collapse>
      </Navbar>
    );
  }
}
