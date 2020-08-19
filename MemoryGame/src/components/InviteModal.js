import React, { useState, useContext, useRef } from 'react'
import ClipboardJS from 'clipboard'
import { Modal, Button, Form, InputGroup, Overlay, Tooltip } from 'react-bootstrap'
import GameContext from '../context/game-context'

//This function provides the invitation functionality

export const InviteModal = () => {
  new ClipboardJS("#btnClipboard")
  const { showInviteModal, setShowInviteModal, gameId } = useContext(GameContext)
  const [showCopyTooltip, setShowCopyTooltip] = useState(false)
  const [inviteUrl, setInviteUrl] = useState("")
  const target = useRef(null)

  useState(() => {
    return setInviteUrl(window.location.host + "/" + gameId)
  }, [])

  return (
    <Modal show={showInviteModal} onHide={() => setShowInviteModal(false)}>
      <Modal.Header closeButton>
        <Modal.Title>This is your invite link</Modal.Title>
      </Modal.Header>

      <Modal.Body>
        <InputGroup>
        <Form.Control ref={target} id="inviteLink" type="text" value={inviteUrl} readOnly style={{backgroundColor:"lightgray"}} />
        <Overlay target={target.current} show={showCopyTooltip} placement="top">
          {props => (
            <Tooltip id="overlay-example" {...props}>
              Copied!
            </Tooltip>
          )}
        </Overlay>
        <InputGroup.Append id="btnClipboard" data-clipboard-target="#inviteLink" onClick={() => setShowCopyTooltip(true)}>
          <InputGroup style={{cursor:"pointer"}} className="btn btn-primary" id="inputGroupPrepend">Copy</InputGroup>
        </InputGroup.Append>
      </InputGroup>
      </Modal.Body>

      <Modal.Footer>
        <div>Share this link to invite your opponents to game</div>
        <Button variant="secondary" onClick={() => setShowInviteModal(false)}>Ok</Button>
      </Modal.Footer>
    </Modal>
  )
}

export { InviteModal as default }