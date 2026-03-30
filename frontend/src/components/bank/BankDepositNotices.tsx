import { bankSidePanelColumnClass } from './BankPageLayout'

/** Desktop-only “গুরুত্বপূর্ণ বিজ্ঞপ্তি” column from legacy bank deposit. */
export function BankDepositNotices() {
  return (
    <div className={`${bankSidePanelColumnClass} bank-deposit-right-rail`}>
      <div style={{ height: '100%' }}>
        <div className="row desktop-right-panel hidden-sm-and-down pa-4 no-gutters">
          <div className="col col-12 pb-0" style={{ height: 'fit-content' }}>
            <p className="right_panel_title">
              <b>গুরুত্বপূর্ণ বিজ্ঞপ্তি</b>
            </p>
            <p className="right_panel_title mb-0">1. শুধুমাত্র অফিসিয়াল ডিপোজিট এবং উইথড্রয়াল চ্যানেল ব্যবহার করুন: </p>
            <p className="right_panel_desc mb-0">
              অনুগ্রহ করে, আমাদের ওয়েবসাইটে নির্ধারিত আমানত এবং উত্তোলন চ্যানেলগুলির মাধ্যমে ডিপোজিট জমা বা উত্তোলন করুন। কোনো অনানুষ্ঠানিক বা তৃতীয় পক্ষের প্ল্যাটফর্ম ব্যবহার করা এড়িয়ে চলুন।
            </p>
            <p className="right_panel_title mb-0">2. যেকোনো সমস্যা বা লেনদেনের জন্য অফিসিয়াল লাইভ চ্যাট ব্যবহার করুন : </p>
            <p className="right_panel_desc mb-0">
              যদি আপনার লেনদেন 15 মিনিটের বেশি সময় ধরে মুলতুবি থাকে, তাহলে অনুগ্রহ করে আমাদের 24/7 লাইভ চ্যাট সহায়তার সাথে যোগাযোগ করুন। আমাদের ডেডিকেটেড টিম আপনাকে অবিলম্বে সহায়তা করতে এবং আপনার লেনদেন পরিস্থিতির রিয়েল-টাইম আপডেট প্রদান করতে প্রস্তুত।
            </p>
            <p className="right_panel_title mb-0">3. ক্যাশ-আউট সম্পর্কে সতর্কতা:</p>
            <p className="right_panel_desc mb-0">
              আপনি আগে ট্রান্সফারের জন্য ব্যবহার করেছেন এমন কোনো পূর্ববর্তী ই-ওয়ালেটে সরাসরি ক্যাশ-আউট করবেন না। আপনার লেনদেনের নিরাপত্তা এবং নির্ভুলতা নিশ্চিত করতে সর্বদা আমাদের নির্দিষ্ট পদ্ধতি অনুসরণ করুন।
            </p>
            <p className="right_panel_title mb-0">4. প্রদত্ত ই-ওয়ালেট নম্বর ব্যবহার করুন:</p>
            <p className="right_panel_desc mb-0">
              ক্যাশ-আউট শুরু করার সময়, নিশ্চিত করুন যে আপনি শুধুমাত্র আমাদের প্ল্যাটফর্মের দেওয়া ই-ওয়ালেট নম্বর ব্যবহার করছেন। এটি আমাদের দক্ষতার সাথে আপনার অনুরোধ প্রক্রিয়া করতে সাহায্য করে এবং ত্রুটির ঝুঁকি কমিয়ে দেয়।
            </p>
            <p className="right_panel_desc">
              এই নির্দেশিকাগুলি আপনার আর্থিক লেনদেনগুলিকে সুরক্ষিত রাখতে এবং আপনার অ্যাকাউন্টকে সুরক্ষিত করার জন্য রয়েছে৷ আপনার কোনো প্রশ্ন বা উদ্বেগ থাকলে, আমাদের গ্রাহক সহায়তা দল আপনাকে সহায়তা করার জন্য লাইভ চ্যাটের মাধ্যমে 24/7 যোগাযোগ করুন।
            </p>
          </div>
        </div>
      </div>
    </div>
  )
}
