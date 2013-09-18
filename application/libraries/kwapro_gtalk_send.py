# -*- coding: utf-8 -*-
import xmpp
import sys

def gtalk_send_message(send_to,text):
    account = 'kwaproq2a@gmail.com'
    password = '851212840607'
    jid = xmpp.protocol.JID(account)
    cl = xmpp.Client(jid.getDomain(),debug=[])
    cl.connect(('talk.google.com',5222))
    cl.auth(jid.getNode(),password)
    Roster = cl.getRoster()
    cl.send(xmpp.protocol.Message(send_to,text,typ="chat"))
    cl.disconnected()
	
if __name__ == '__main__':
    send_to = sys.argv[1]
    text = sys.argv[2]
    gtalk_send_message(send_to,text)