//
//  IndividualJobViewController.swift
//  WhizBridge
//
//  Created by George Utsin on 2015-09-19.
//  Copyright (c) 2015 WhizBridge. All rights reserved.
//

import UIKit

class IndividualJobViewController: UIViewController {

    @IBOutlet weak var label: UILabel!
    
    @IBOutlet weak var descriptionText: UITextView!
    @IBOutlet weak var price: UILabel!
    @IBOutlet weak var address: UILabel!
    var currentJob :Job!
    override func viewDidLoad() {
        super.viewDidLoad()
        label.text = "Name: \(currentJob.job_name!)"
        descriptionText.text = "Description: " + currentJob.job_description!
        price.text = "Potential Earnings: $\(currentJob.job_price!)"
        address.text = currentJob.job_address
        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBAction func backPressed(sender: AnyObject) {
        self.navigationController!.dismissViewControllerAnimated(true, completion: nil)
    }

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
