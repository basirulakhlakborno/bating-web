import { useEffect, useState } from 'react'

export type InboxMessage = {
  id: string
  title: string
  date: string
  time: string
}

function EnvelopeIcon() {
  return (
    <svg width="16" height="15" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden>
      <path
        d="M15.51 4.83L8.745.227a1.333 1.333 0 00-1.488 0L.489 4.83A1.11 1.11 0 000 5.748v8.136C0 14.499.51 15 1.136 15h13.728c.627 0 1.136-.5 1.136-1.116V5.748c0-.367-.183-.71-.49-.918zM7.763.945a.427.427 0 01.476 0l6.45 4.388-6.482 4.41a.367.367 0 01-.412 0l-6.482-4.41L7.762.945zm7.102 13.182H1.136a.245.245 0 01-.247-.243V6.108l6.399 4.352c.213.146.462.218.712.218.25 0 .5-.072.712-.217l6.4-4.353v7.776c0 .134-.112.242-.248.242z"
        fill="#6C6C6C"
      />
    </svg>
  )
}

function TrashIcon() {
  return (
    <svg width="12" height="15" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden>
      <path
        fillRule="evenodd"
        clipRule="evenodd"
        d="M10.766 2.859l-9.528-.012a.36.36 0 00-.358.356v.358l3.78.005c2.154 0 4.308.002 6.462.008v-.357a.36.36 0 00-.356-.358zm-3.623 3.11a.441.441 0 01.882 0v5.724a.441.441 0 01-.882 0V5.97zm-3.17 0a.441.441 0 11.883 0v5.724a.442.442 0 01-.882 0V5.97zM12 3.218l-.001.797a.441.441 0 01-.44.44h-.352l-.758 9.501C10.4 14.57 9.839 15 9.224 15H2.822c-.615 0-1.173-.428-1.225-1.04L.793 4.44H.439A.439.439 0 010 4l.001-.797a1.238 1.238 0 011.237-1.235l1.842.002c.128-.52.433-.98.863-1.3 1.148-.894 2.97-.894 4.12.002.431.321.737.783.864 1.305l1.84.003A1.237 1.237 0 0112 3.217zm-3.995-1.24a1.523 1.523 0 00-.483-.612c-.827-.644-2.209-.645-3.038 0-.21.157-.377.365-.484.605l4.005.005v.001zm2.318 2.475l-8.645-.004.797 9.44c.012.143.19.229.346.229h6.403c.158 0 .335-.087.347-.23l.752-9.435z"
        fill="#6C6C6C"
      />
    </svg>
  )
}

type InboxTab = 'inbox' | 'notices'

export function ProfileInboxMain({
  messages = [],
}: {
  messages?: InboxMessage[]
}) {
  const [tab, setTab] = useState<InboxTab>('inbox')
  const [selectedIds, setSelectedIds] = useState<Set<string>>(new Set())

  const list = tab === 'inbox' ? messages : []
  const allSelected = list.length > 0 && selectedIds.size === list.length

  useEffect(() => {
    setSelectedIds(new Set())
  }, [tab])

  const toggleOne = (id: string) => {
    setSelectedIds((prev) => {
      const next = new Set(prev)
      if (next.has(id)) next.delete(id)
      else next.add(id)
      return next
    })
  }

  const toggleAll = () => {
    if (allSelected) {
      setSelectedIds(new Set())
    } else {
      setSelectedIds(new Set(list.map((m) => m.id)))
    }
  }

  return (
    <div className="v-card v-sheet theme--light desktop_inbox_card profile-inbox-card-wrap">
      <div className="v-card__title justify-space-between profile-inbox-title-row">
        <label className="--v-primary-base text-left ml-4 inbox-desktop-txt">ইনবক্স বার্তা</label>
      </div>
      <div className="row profile-inbox-tab-row no-gutters justify-end">
        <div className="text-left col col-12">
          <button
            type="button"
            onClick={() => setTab('inbox')}
            className={`tab-btn v-btn v-btn--has-bg theme--light v-size--default${tab === 'inbox' ? ' selected-tab' : ' not-selected-tab'}`}
          >
            <span className="v-btn__content">ইনবক্স</span>
          </button>
          <button
            type="button"
            onClick={() => setTab('notices')}
            className={`tab-btn v-btn v-btn--has-bg theme--light v-size--default${tab === 'notices' ? ' selected-tab' : ' not-selected-tab'}`}
          >
            <span className="v-btn__content">বিজ্ঞপ্তি</span>
          </button>
        </div>
      </div>
      <div className="row hidden-sm-and-down pt-6 pb-3 voucher-border no-gutters align-end">
        <div className="col">
          <hr role="separator" aria-orientation="horizontal" className="v-divider theme--light" />
        </div>
      </div>

      <div className="inbox-card profile-detail-card v-card v-sheet theme--light elevation-0">
        {tab === 'inbox' ? (
          <>
            <div className="row ma-1 inbox-details-header">
              <div className="pa-0 col col-1">
                <label className="inbox-checkbox-label">
                  <input
                    type="checkbox"
                    className="inbox-checkbox"
                    checked={allSelected}
                    onChange={toggleAll}
                    aria-label="সব বাছাই"
                  />
                </label>
              </div>
              <div className="pa-0 pt-2 col col-7">
                <span className="inbox-sub ml-3">বাছাই করুন/বাছাই বাতিল করুন</span>
              </div>
              <div className="pa-0 col col-2">
                <button type="button" className="icon-btn mt-0 v-btn v-btn--has-bg theme--light elevation-0 v-size--default inbox-toolbar-btn">
                  <span className="v-btn__content inbox-toolbar-btn-inner">
                    <EnvelopeIcon />
                    <span className="inbox-sub ml-3">পড়েছেন চিহ্নিত করুন</span>
                  </span>
                </button>
              </div>
              <div className="pa-0 text-center col col-2">
                <button type="button" className="icon-btn mt-0 v-btn v-btn--has-bg theme--light elevation-0 v-size--default inbox-toolbar-btn">
                  <span className="v-btn__content inbox-toolbar-btn-inner">
                    <TrashIcon />
                    <span className="inbox-sub ml-3">মুছে ফেলা</span>
                  </span>
                </button>
              </div>
            </div>

            <div className="row pa-4 no-gutters align-start justify-start pt-1 profile-inbox-list">
              <div className="col col-12">
                {list.length === 0 ? (
                  <p className="profile-inbox-empty mb-0">কোন বার্তা নেই।</p>
                ) : (
                  list.map((m) => (
                    <div key={m.id} className="row py-1 inbox-content no-gutters">
                      <div className="col col-1">
                        <label className="inbox-checkbox-label">
                          <input
                            type="checkbox"
                            className="inbox-checkbox"
                            checked={selectedIds.has(m.id)}
                            onChange={() => toggleOne(m.id)}
                            aria-label={`বাছাই ${m.title}`}
                          />
                        </label>
                      </div>
                      <div className="col col-8">
                        <div className="row no-gutters">
                          <div className="mb-3 col col-12">
                            <label className="font-weight-bold inbox-msg-title">{m.title}</label>
                          </div>
                        </div>
                      </div>
                      <div className="text-right pr-4 col col-2">
                        <span className="inbox-msg-meta">{m.date}</span>
                      </div>
                      <div className="col col-1">
                        <span className="inbox-msg-meta">{m.time}</span>
                      </div>
                    </div>
                  ))
                )}
              </div>
            </div>
          </>
        ) : (
          <div className="pa-6">
            <p className="profile-inbox-empty mb-0">কোন বিজ্ঞপ্তি নেই।</p>
          </div>
        )}
      </div>
    </div>
  )
}
